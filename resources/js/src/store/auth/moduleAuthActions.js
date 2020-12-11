import router from '@/router'
import auth from '@/auth/authService.js'

export default {
  loginJWT ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      auth.login(payload.userDetails)
        .then(response => {
          if (response.data && response.data.user) {
            commit('UPDATE_USER_INFO', response.data.user, {root: true})
            commit('SET_BEARER', response.data.access_token)
            router.push(router.currentRoute.query.to || '/')
            resolve(response)
          } else if (response.data.error) {
            reject({message: response.data.error})
          }
        })
        .catch(error => {
          reject(error)
        })
    })
  },
  registerUserJWT ({ commit }, payload) {
    const { user_name, email, password, confirmPassword } = payload.userDetails
    return new Promise((resolve, reject) => {
      // Check confirm password
      if (password !== confirmPassword) {
        reject({message: 'Password doesn\'t match. Please try again.'})
      }

      auth.registerUser(user_name, email, password)
        .then(response => {
          if (response.data.token) {
            let token = response.data.token            
            router.push({ path: `/email-verify/${token}` })
            resolve(response)
          }
          else if (response.data.error) {
            reject({message: response.data.error})
          }
        })
        .catch(error => { reject(error) })
    })
  },
  emailVerify ( { commit }, payload) {
    const { token, verification_code } = payload.verify_details
    return new Promise((resolve, reject) => {
      auth.verifyEmail(token, verification_code)
        .then(response => {
          if (response.data.user) {
            router.push('/login')
            resolve(response)
          }
          else {
            reject({message: 'Failed email verification'})
          }
        })
        .catch(error => { reject(error) })
    })
  },
  fetchAccessToken () {
    return new Promise((resolve, reject) => {
      jwt.refreshToken()
        .then(response => { 
          resolve(response) 
        })
        .catch(error => {
          reject(error)
        })
    })
  },
  updateUser ({ commit }, user) {
    return new Promise((resolve, reject) => {
      auth.updateUser(user)
        .then((response) => {
          commit('UPDATE_USER_INFO', response.data, {root: true})
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  changePassword ({ commit }, item) {
    return new Promise((resolve, reject) => {
      auth.changePassword(item)
        .then((response) => {
          if (response.data) {
            resolve(response)
          }
        })
        .catch(error => {
          reject(error)
        })
    })
  },
  emailConfigure ({ commit }, item) {
    return new Promise((resolve, reject) => {
      auth.emailConfigure(item)
        .then((response) => {
          if (response.data) {
            resolve(response)
          }
        })
        .catch(error => {
          reject(error)
        })
    })
  },
  forgotPassword ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      auth.forgotPassword(payload)
        .then((response) => {
          if (response.data) {
            resolve(response.data)
          }
        })
        .catch(error => {
          reject(error)
        })
    })
  },
  resetPassword ( { commit }, payload) {
    return new Promise((resolve, reject) => {
      auth.resetPassword(payload)
        .then((response) => {
          if (response.data) {
            resolve(response.data)
          }
        })
        .catch(error => {
          reject(error)
        })
    })
  }
}
