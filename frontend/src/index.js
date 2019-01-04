import React from 'react'
import ReactDOM from 'react-dom'
import App from './App'
import store from './store'
import {saveUser} from "./store/actions"

if (localStorage.getItem('user')) {
  let user = JSON.parse(localStorage.getItem('user'))
  store.dispatch(saveUser(user))
}

ReactDOM.render(<App />, document.getElementById('root'))