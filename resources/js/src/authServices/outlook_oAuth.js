import * as msal from 'msal';

let msalApp
const msalScopes = ['user.read', 'openid', 'contacts.read', 'calendars.read']

export default {  
  configure() {
    const msalConfig = {
      auth: {
        clientId: '847510dc-9f2d-45e2-8c5c-53aa27af15bf',
        redirectUri: window.location.origin,
      },
    }

    msalApp = new msal.UserAgentApplication(msalConfig)
  },
  async login() {
    if (!msalApp) return null

    let idToken = await msalApp.loginPopup({
      scopes: msalScopes,
      prompt: 'select_account',
    })

    return idToken;

  },
  user() {
    if (!msalApp) return null

    return msalApp.getAccount()
  },
  async logout() {
    if (!msalApp) return

    await msalApp.logout()
  },
  async acquireToken() {
    if (!msalApp) { return null }

    const accessTokenRequest = {
      scopes: msalScopes
    }

    let tokenResp

    try {
      tokenResp = await msalApp.acquireTokenSilent(accessTokenRequest)
    } catch (error) {
      tokenResp = await msalApp.acquireTokenPopup(accessTokenRequest)
    }

    if (!tokenResp.accessToken) {
      throw new Error('### accessToken not found in response, that\'s bad')
    }

    return tokenResp.accessToken
  }
}