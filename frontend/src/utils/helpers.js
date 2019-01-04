import { JWT_TOKEN, USER_KEY, CSRF_KEY } from './constants'

export const getRequestConfig = () => {
  const token = localStorage.getItem(JWT_TOKEN)
  const csrf_token = getCookie(CSRF_KEY)

  return {
    headers: {
      Authorization: `Bearer ${token}`,
      "X-XSRF-TOKEN": csrf_token
    }
  }
}

export const clearLocalStorage = () => {
  localStorage.removeItem(JWT_TOKEN)
  localStorage.removeItem(USER_KEY)
}

export const setToken = token => {
  localStorage.setItem(JWT_TOKEN, token)
}

export const setUser = user => {
  const userString = JSON.stringify(user)
  localStorage.setItem(USER_KEY, userString)
}

export const getToken = () => {
  return localStorage.getItem(JWT_TOKEN)
}

export const getUser = () => {
  const user = localStorage.getItem(USER_KEY)

  return JSON.parse(user)
}

export const clearStorage = () => {
  localStorage.removeItem(JWT_TOKEN)
  localStorage.removeItem(USER_KEY)
}

export const getCookie = (cname) => {
  let name = cname + "="
  let decodedCookie = decodeURIComponent(document.cookie)
  let ca = decodedCookie.split('')
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i]
    while (c.charAt(0) === ' ') {
      c = c.substring(1)
    }
    if (c.indexOf(name) === 0) {
      return c.substring(name.length, c.length)
    }
  }
  return ""
}

export const isLoggedIn = () => {
  const token = getToken()
  if (!token) return false
  return true
}

export const hasRole = (role) => {
  role = role.toUpperCase()
  return false
}