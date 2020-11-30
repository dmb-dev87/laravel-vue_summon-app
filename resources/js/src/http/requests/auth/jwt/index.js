import axios from '../../../axios/index.js'
import store from '../../../../store/store.js'

// Token Refresh
let isAlreadyFetchingAccessToken = false
let subscribers = []

function onAccessTokenFetched (access_token) {
  subscribers = subscribers.filter(callback => callback(access_token))
}

function addSubscriber (callback) {
  subscribers.push(callback)
}

export default {
  init () {
    axios.interceptors.response.use(function (response) {
      return response
    }, function (error) {
      const { config, response } = error
      const originalRequest = config

      if (response && response.status === 401) {
        if (!isAlreadyFetchingAccessToken) {
          isAlreadyFetchingAccessToken = true
          store.dispatch('auth/fetchAccessToken')
            .then((access_token) => {
              isAlreadyFetchingAccessToken = false
              onAccessTokenFetched(access_token)
            })
        }

        const retryOriginalRequest = new Promise((resolve) => {
          addSubscriber(access_token => {
            originalRequest.headers.Authorization = `Bearer ${access_token}`
            resolve(axios(originalRequest))
          })
        })
        return retryOriginalRequest
      }

      return Promise.reject(error)
    })
  },
  login (email, pwd) {
    return axios.post('/api/auth/login', {email, password: pwd})
  },
  registerUser (user_name, email, pwd) {
    return axios.post('/api/auth/register', {user_name: user_name, email, password: pwd})
  },
  verifyEmail (token, code) {
    return axios.post('/api/email-verify', {email_verification_token: token, verification_code: code})
  },
  refreshToken () {
    return axios.post('/api/auth/refresh', {accessToken: localStorage.getItem('accessToKen')})
  }
}
