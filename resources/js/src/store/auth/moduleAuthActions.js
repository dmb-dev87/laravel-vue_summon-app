import jwt from '../../http/requests/auth/jwt/index.js'
import axios from '@/axios.js'
import router from '@/router'

export default {
  // JWT
  loginJWT ({ commit }, payload) {

    return new Promise((resolve, reject) => {

      jwt.login(payload.userDetails.email, payload.userDetails.password)
        .then(response => {
          // If there's user data in response
          if (response.data.user) {
            // Set accessToken
            localStorage.setItem('localStorageKey', true)
            localStorage.setItem('accessToken', response.data.access_token)

            // Update user details
            commit('UPDATE_USER_INFO', response.data.user, {root: true})

            // Set bearer token in axios
            commit('SET_BEARER', response.data.access_token)

            // Navigate User to homepage
            router.push(router.currentRoute.query.to || '/')

            resolve(response)
          } else {
            reject({message: 'Wrong Email or Password'})
          }
        })
        .catch(error => { reject(error) })
    })
  },
  registerUserJWT ({ commit }, payload) {

    const { user_name, email, password, confirmPassword } = payload.userDetails

    return new Promise((resolve, reject) => {

      // Check confirm password
      if (password !== confirmPassword) {
        reject({message: 'Password doesn\'t match. Please try again.'})
      }

      jwt.registerUser(user_name, email, password)
        .then(response => {
          if (response.data.user) {
            // Redirect login
            router.push('/login')
            resolve(response)  
          }
          else {
            reject({message: 'Failed register'})
          }
        })
        .catch(error => { reject(error) })
    })
  },
  fetchAccessToken () {
    return new Promise((resolve) => {
      jwt.refreshToken().then(response => { resolve(response) })
    })
  },
  upateUser ({ commit }, item) {
    return new Promise((resolve, reject) => {
      axios.put(`/api/users/${item.id}`, {item})
        .then((response) => {
          commit('UPDATE_USER_INFO', response.data, {root: true})
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
