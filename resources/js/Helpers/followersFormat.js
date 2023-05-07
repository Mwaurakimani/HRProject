export default function followersFormat(followers) {
    let followersFormatted;

    if (followers < 1000) {
        followersFormatted = Math.trunc(followers / 1000)
        followersFormatted = followersFormatted+"K"
    }else if (followers >= 1000 && followers < 1000000) {
        followersFormatted = Math.trunc(followers / 1000)
        followersFormatted = followersFormatted+"K"
    }else if (followers >= 1000000 && followers < 1000000000){
        followersFormatted = Math.trunc(followers / 1000000)
        followersFormatted = followersFormatted+"M"
    }else {
        followersFormatted = Math.trunc(followers / 1000000000)
        followersFormatted = followersFormatted+"B"
    }

    return followersFormatted
}
