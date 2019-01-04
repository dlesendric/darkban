import React, { Component, Fragment } from 'react'

import Navigation from './../shared/Navigation'
import Footer from './../shared/Footer'
import API from '../../utils/api'
import { setToken, setUser, isLoggedIn } from "../../utils/helpers"
import store from '../../store'
import { saveUser } from "../../store/actions"
import History from '../../utils/history'
import Loader from '../shared/Loader'
import classNames from 'classnames';
class Login extends Component {
  constructor(props) {
    super(props)

    this.state = {
      email: '',
      password: '',
      isLoading: false,
      errorMessage: false
    }

    if (isLoggedIn()) {
      History.push('/')
    }
  }

  onChange = (event) => {
    this.setState({
      [event.target.name]: event.target.value,
      errorMessage: false
    })
  }

  onSubmit = (event) => {
    event.preventDefault()

    this.setState({
      isLoading: true
    })

    const data = {
      'username': this.state.email,
      'password': this.state.password
    }

    API.post('/api/authentication', data)
      .then((res) => {
        setToken(res.data.token)
        setUser(res.data.user)

        store.dispatch(saveUser(res.data.user))

        this.setState({
          isLoading: false,
        })

        History.push('/')
      }).catch((res) => {
        if (res.response.status === 401) {
          this.setState({
            errorMessage: 'Invalid email or password',
            isLoading: false
          })
        }
      })
  }

  render() {
    const { isLoading, errorMessage } = this.state
    return (
      <Fragment>
        <Navigation />
        <div className="c-login">
          <div className="container">
            <div className="row justify-content-center">
              <div className="col-4">
                <p className={classNames('text-danger', { 'd-none': !errorMessage })}>{errorMessage}</p>
                <form className="o-form" onSubmit={(event) => { this.onSubmit(event) }}>
                  <div className="form-group">
                    <label className="o-form__label">E-Mail</label>
                    <input className="form-control" onKeyUp={(event) => { this.onChange(event) }} type="text" name="email" placeholder="E-Mail" />
                  </div>
                  <div className="form-group">
                    <label className="o-form__label">Password</label>
                    <input className="form-control" onKeyUp={(event) => { this.onChange(event) }} type="password" name="password" placeholder="Password" />
                  </div>
                  <div className="o-form__butons">
                    <button className="btn btn-primary btn-block" type="submit">
                      {isLoading ? <Loader /> : 'Login'}
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <Footer />
      </Fragment>
    )
  }
}

export default Login
