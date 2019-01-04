import React, { Component, Fragment } from 'react'
import { Link } from 'react-router-dom'
import { clearStorage, isLoggedIn } from '../../utils/helpers'
import store from "../../store"
import { logout } from "../../store/actions"
import History from '../../utils/history'

class Navigation extends Component {
  logout = () => {
    store.dispatch(logout())
    clearStorage()

    History.push('/')
  }

  renderLinks = () => {
    if (isLoggedIn()) {
      return (
        <Fragment>
          <li className="nav-item">
            <Link to="/boards" className="btn btn-default text-primary nav-link">Boards</Link>
          </li>
          <li className="nav-item">
            <button type="button" className="btn btn-default nav-link" rel="noopener" onClick={() => { this.logout() }}>Logout</button>
          </li>
        </Fragment>
      )
    }

    return (
      <Fragment>
        <li className="nav-item">
          <Link to="/login" className="nav-link">Login</Link>
        </li>
        <li className="nav-item">
          <Link to="/register" className="btn btn-primary">Try for free</Link>
        </li>
      </Fragment>
    )
  }

  render() {
    return (
      <nav className="navbar navbar-expand-lg navbar-light bg-light">
        <div className="container">
          <Link to="/" className="navbar-brand" href="/">Darkban</Link>
          <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span className="navbar-toggler-icon"></span>
          </button>

          <div className="collapse navbar-collapse" id="navbarSupportedContent">
            <ul className="navbar-nav ml-auto">
              {this.renderLinks()}
            </ul>
          </div>
        </div>
      </nav>
    )
  }
}

export default Navigation
