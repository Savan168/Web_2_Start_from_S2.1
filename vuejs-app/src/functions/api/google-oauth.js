import axios from 'axios';

const APP_API_URL = import.meta.env.VITE_APP_API_URL;

export async function apiSocialOAuthRedirect(driver) {
  try {
    const callbackUrl = import.meta.env[`VITE_APP_${driver.toUpperCase()}_OAUTH_CALLBACK_URL`];
    return await axios.get(APP_API_URL + `/${driver}/oauth/redirect`, {
      params: {
        callback_url: callbackUrl
      }
    });
  } catch (error) {
    throw error;
  }
}

export async function apiSocialOAuthExchangeToken(driver, token) {
  try {
    return await axios.post(APP_API_URL + `/${driver}/oauth/exchange/token`, null, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
  } catch (error) {
    throw error;
  }
}
