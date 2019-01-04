import { combineReducers } from 'redux'
import authenticationReducer from './auth'
import boardReducer from './boards'
import usersReducer from './users'
import listsReducer from './lists'
import commonReducer from './common'

const rootReducer = combineReducers({
  auth: authenticationReducer,
  boards: boardReducer,
  users: usersReducer,
  lists: listsReducer,
  modal: commonReducer,
})

export default rootReducer