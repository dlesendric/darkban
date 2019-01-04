import { LOGOUT, SAVE_USER } from "../actions/types"

const initialState = {
  user: null
}

const saveUser = (state, action) => {
  return { ...state, user: action.user }
}

const removeUser = (state, action) => {
  return { ...state, user: null }
}

const authenticationReducer = (state = initialState, action) => {
  switch (action.type) {
    case SAVE_USER: return saveUser(state, action)
    case LOGOUT: return removeUser(state, action)
    default: return state
  }
}

export default authenticationReducer