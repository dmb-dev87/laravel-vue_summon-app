import auth from '@/authServices/jwt_authService.js'

export default {
  isUserLoggedIn: () => {
    let isAuthenticated = false

    if (auth.isAuthenticated()) 
      isAuthenticated = true
    else 
      isAuthenticated = false

    return localStorage.getItem('userInfo') && isAuthenticated
  }
}
