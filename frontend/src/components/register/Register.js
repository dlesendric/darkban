import React, { Component, Fragment } from 'react'

import Navigation from './../shared/Navigation'
import Footer from './../shared/Footer'
import API from '../../utils/api'
import History from '../../utils/history'
import { isLoggedIn } from '../../utils/helpers'
import Loader from '../shared/Loader'

class Register extends Component {
  constructor(props) {
    super(props)

    this.state = {
      firstName: '',
      lastName: '',
      email: '',
      password: '',
      repeatPassword: '',
      isLoading: false
    }

    if (isLoggedIn()) {
      History.push('/')
    }
  }

  onChange = (event) => {
    this.setState({
      [event.target.name]: event.target.value
    })
  }

  onSubmit = (event) => {
    event.preventDefault()

    this.setState({
      isLoading: true
    })

    const data = {
      email: this.state.email,
      firstName: this.state.firstName,
      lastName: this.state.lastName,
      plainPassword: {
        first: this.state.password,
        second: this.state.repeatPassword
      }
    }

    API.post('/api/users', data)
      .then((res) => {
        History.push('/login')

        this.setState({
          isLoading: false
        })
      }).catch((res) => {
        console.log(res)
      })
  }

  render() {
    const { isLoading } = this.state
    
    return (
      <Fragment>
        <Navigation />
        <div className="c-register">
          <div className="container">
            <div className="row justify-content-center">
              <div className="col-4">
                <form className="o-form" onSubmit={(event) => { this.onSubmit(event) }}>
                  <div className="form-group">
                    <label className="o-form__label">First name</label>
                    <input className="form-control" onKeyUp={(event) => { this.onChange(event) }} type="text" name="firstName" placeholder="E-Mail" />
                  </div>
                  <div className="form-group">
                    <label className="o-form__label">Last name</label>
                    <input className="form-control" onKeyUp={(event) => { this.onChange(event) }} type="text" name="lastName" placeholder="Last name" />
                  </div>
                  <div className="form-group">
                    <label className="o-form__label">E-Mail</label>
                    <input className="form-control" onKeyUp={(event) => { this.onChange(event) }} type="text" name="email" placeholder="E-Mail" />
                  </div>
                  <div className="form-group">
                    <label className="o-form__label">Password</label>
                    <input className="form-control" onKeyUp={(event) => { this.onChange(event) }} type="password" name="password" placeholder="Password" />
                  </div>
                  <div className="form-group">
                    <label className="o-form__label">Repeat Password</label>
                    <input className="form-control" onKeyUp={(event) => { this.onChange(event) }} type="password" name="repeatPassword" placeholder="Password" />
                  </div>
                  <div className="o-form__butons">
                    <button className="btn btn-primary btn-block" type="submit" value="Register">
                      {isLoading ? <Loader /> : 'Register'}
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

export default Register
