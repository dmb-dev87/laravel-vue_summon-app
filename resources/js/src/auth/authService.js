import EventEmitter from 'events'
import jwt from '@/http/requests/auth/jwt/index.js'

// 'loggedIn' is used in other parts of application. So, Don't forget to change there also
const localStorageKey = 'loggedIn'
const tokenExpiryKey = 'tokenExpiry'
const loginEvent = 'loginEvent'
const accessToken = 'accessToken'

class AuthService extends EventEmitter {
  idToken = null;
  profile = null;
  tokenExpiry = null;

  login(user) {
    return jwt.login(user.email, user.password)
      .then(response => {
        // If there's user data in response
        if (response.data.access_token) {
          // Set accessToken
          localStorage.setItem(localStorageKey, true)
          localStorage.setItem(accessToken, response.data.access_token)

          let now = new Date();
          this.tokenExpiry = new Date(now.getTime() + response.data.expires_in*1000)
          localStorage.setItem(tokenExpiryKey, this.tokenExpiry)
        }
        return response
      })
  }

  registerUser(user_name, email, password) {
    return jwt.registerUser(user_name, email, password)
  }

  verifyEmail(token, verification_code) {
    return jwt.verifyEmail(token, verification_code)
  }

  isAuthenticated () {
    return (
      (new Date(Date.now()) < new Date(localStorage.getItem(tokenExpiryKey))) && 
        (localStorage.getItem(localStorageKey) === 'true')
    )
  }

  updateUser (user) {
    return jwt.updateUser(user)
      .then((response) => {
        return response
      })
  }

  changePassword (item) {
    return jwt.changePassword(item.old_password, item.new_password, item.confirm_password)
  }

  emailConfigure(item) {
    return jwt.emailConfigure(item.email_type, item.access_token)
  }
}

export default new AuthService()
