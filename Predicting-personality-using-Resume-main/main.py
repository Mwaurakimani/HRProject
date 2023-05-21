import nltk
import re
from fastapi import FastAPI, File, UploadFile
from pydantic import BaseModel

import nltk
import pandas as pd
from pdfminer.high_level import extract_text
from sklearn import linear_model

PHONE_REG = re.compile(r"[+(]?[1-9][\d .\-()]{8,}\d")
EMAIL_REG = re.compile(r'[a-z\d.\-+_]+@[a-z\d.\-+_]+\.[a-z]+')
SKILLS_DB = [
  'machine learning',
  'data science',
  'python',
  'word',
  'excel',
  'English',
]

app = FastAPI()


class RequestBody(BaseModel):
  name: str | None
  age: int
  gender: int
  openness: int
  neuroticism: int
  conscientiousness: int
  agreeableness: int
  extraversion: int


@app.post("/process_trait")
async def process(RequestBody: RequestBody):
  if RequestBody is not None:

    name = RequestBody.name
    age = RequestBody.age
    gender = RequestBody.gender
    openness = RequestBody.openness
    neuroticism = RequestBody.neuroticism
    conscientiousness = RequestBody.conscientiousness
    agreeableness = RequestBody.agreeableness
    extraversion = RequestBody.extraversion

    Prediction = prediction_result(name,
                                   (gender, age, openness, neuroticism, conscientiousness, agreeableness, extraversion))

    if Prediction is not None:
      Prediction = Prediction[0]
    else:
      Prediction = None

    return {
      'status': True,
      'data': Prediction
    }

  else:
    return {
      'status': False,
      'data': None
    }


@app.post("/process_resume")
async def process(file: UploadFile = File(...)):
  filename = file.filename
  file = extract_text_from_pdf(filename)
  name = extract_names(file)
  phone = extract_phone_number(file)
  email = extract_emails(file)
  skills = extract_skills(file)

  cvData = {
    'name': name[0],
    'phone': phone,
    'email': email[0] if email[0] else [],
    'skills': skills
  }

  return(cvData)


class train_model:
  def train(self):
    data = pd.read_csv('training_dataset.csv')
    array = data.values

    for i in range(len(array)):
      if array[i][0] == "Male":
        array[i][0] = 1
      else:
        array[i][0] = 0

    df = pd.DataFrame(array)

    maindf = df[[0, 1, 2, 3, 4, 5, 6]]
    mainarray = maindf.values

    temp = df[7]
    train_y = temp.values

    self.mul_lr = linear_model.LogisticRegression(multi_class='multinomial', solver='newton-cg', max_iter=1000)
    self.mul_lr.fit(mainarray, train_y)

  def test(self, test_data):
    try:
      test_predict = list()
      for i in test_data:
        test_predict.append(int(i))
      y_pred = self.mul_lr.predict([test_predict])
      return y_pred
    except:
      print("All Factors For Finding Personality Not Entered!")


def prediction_result(aplcnt_name, personality_values):
  model = train_model()
  model.train()
  personality = model.test(personality_values)
  return personality


def extract_text_from_pdf(pdf_path):
  return extract_text(pdf_path)


def extract_names(txt):
  person_names = []

  for sent in nltk.sent_tokenize(txt):
    for chunk in nltk.ne_chunk(nltk.pos_tag(nltk.word_tokenize(sent))):
      if hasattr(chunk, 'label') and chunk.label() == 'PERSON':
        person_names.append(
          ' '.join(chunk_leave[0] for chunk_leave in chunk.leaves())
        )

  return person_names


def extract_phone_number(resume_text):
  phone = re.findall(PHONE_REG, resume_text)

  if phone:
    number = ''.join(phone[0])

    if resume_text.find(number) >= 0 and len(number) < 16:
      return number
  return None


def extract_emails(resume_text):
  return re.findall(EMAIL_REG, resume_text)


def extract_skills(input_text):
  stop_words = set(nltk.corpus.stopwords.words('english'))
  word_tokens = nltk.tokenize.word_tokenize(input_text)

  # remove the stop words
  filtered_tokens = [w for w in word_tokens if w not in stop_words]

  # remove the punctuation
  filtered_tokens = [w for w in word_tokens if w.isalpha()]

  # generate bigrams and trigrams (such as artificial intelligence)
  bigrams_trigrams = list(map(' '.join, nltk.everygrams(filtered_tokens, 2, 3)))

  # we create a set to keep the results in.
  found_skills = set()

  # we search for each token in our skills database
  for token in filtered_tokens:
    if token.lower() in SKILLS_DB:
      found_skills.add(token)

  # we search for each bigram and trigram in our skills database
  for ngram in bigrams_trigrams:
    if ngram.lower() in SKILLS_DB:
      found_skills.add(ngram)

  return found_skills


if __name__ == "__main__":
  model = train_model()
  model.train()

