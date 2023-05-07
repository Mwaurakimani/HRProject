import {authStore} from "../../Store/AuthStore";
import {useAttrs} from "vue";

export default function authenticate(){
    const auth = authStore()
    const authUser = useAttrs().auth != null && useAttrs().auth.user ? useAttrs().auth.user : null;

    if (authUser){
        auth.authenticate(authUser)
    }
}
