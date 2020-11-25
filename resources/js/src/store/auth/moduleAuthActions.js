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
            // Navigate User to homepage
            router.push(router.currentRoute.query.to || '/')

            // Set accessToken
            localStorage.setItem('accessToken', response.data.access_token)

            // Update user details
            commit('UPDATE_USER_INFO', response.data.user, {root: true})

            // Set bearer token in axios
            commit('SET_BEARER', response.data.access_token)

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
          // Redirect User
          router.push(router.currentRoute.query.to || '/')

          // Update data in localStorage
          localStorage.setItem('accessToken', response.data.accessToken)
          commit('UPDATE_USER_INFO', response.data.userData, {root: true})

          resolve(response)
        })
        .catch(error => { reject(error) })
    })
  },
  fetchAccessToken () {
    return new Promise((resolve) => {
      jwt.refreshToken().then(response => { resolve(response) })
    })
  },
  upateUser ( { commit }, item)
  {
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
