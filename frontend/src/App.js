import React, { Component } from 'react'
import { Router, Switch } from 'react-router-dom'
import { Route } from "react-router"

import 'bootstrap/dist/css/bootstrap.min.css'
import './assets/scss/app.scss'
import 'react-dragula/dist/dragula.min.css'

import { Provider } from 'react-redux'
import { clearLocalStorage } from "./utils/helpers"
import History from './utils/history'
import store from './store'
import api from "./utils/api"
import { logout } from "./store/actions"

import Home from './components/home/Home'
import Login from './components/login/Login'
import Register from './components/register/Register'
import Boards from './components/boards/Boards'

import ProtectedRoute from './HOC/ProtectedRoute'
import { JWT_TOKEN } from "./utils/constants"
import ViewBoard from './components/boards/board/ViewBoard'

import 'jquery'
import 'bootstrap/dist/js/bootstrap.min'

api.interceptors.request.use(
  config => {
    if (localStorage.getItem(JWT_TOKEN)) {
      config.headers.Authorization = 'Bearer ' + localStorage.getItem(JWT_TOKEN)
    }
    return config
  },
  error => Promise.reject(error)
)

api.interceptors.response.use(null, function (error) {
  if (error.response.status === 401) {
    clearLocalStorage()
    store.dispatch(logout())
    History.push('/login')
  }

  if (error.response.status === 403) {
    History.push('/login')
  }

  return Promise.reject(error)
})

class App extends Component {
  render() {
    return (
      <div className="App">
        <Provider store={store}>
          <Router history={History}>
            <Switch>
              <Route exact path="/" component={Home} />
              <Route path="/login" component={Login} />
              <Route path="/register" component={Register} />
              <ProtectedRoute path="/boards" component={Boards} />
              <ProtectedRoute path="/board/:id" component={ViewBoard} />
            </Switch>
          </Router>
        </Provider>
      </div>
    )
  }
}

export default App
