import React, { Component, Fragment } from 'react'

import { Link } from "react-router-dom"

import Navigation from './../shared/Navigation'
import Footer from './../shared/Footer'
import { isLoggedIn, getUser } from '../../utils/helpers'

class Home extends Component {
  renderWelcomeMessage = () => {
    if (!isLoggedIn()) {
      return (
        <Fragment>
          <Link to="/register" className="btn btn-primary">Try for free</Link>
          <p>Already have an account? Log in <Link to="/login">here</Link>.</p>
        </Fragment>
      )
    }
    return (
      <p className="text-center">Hello, <strong>{getUser().firstName}</strong>.<br /> Navigate to Boards page and have some fun. :)</p>
    )
  }
  render() {
    return (
      <Fragment>
        <Navigation />
        <div className="container">
          <main className="c-welcome">
            <h1 className="c-welcome__heading">Welcome to Darkban!</h1>
            <p>Simple project managment tool made by Darko Lesendric.</p>
            {this.renderWelcomeMessage()}
          </main>
        </div>
        <Footer />
      </Fragment>
    )
  }
}

export default Home
