import React from 'react'
import { Route, Redirect } from 'react-router-dom'
import { isLoggedIn } from '../utils/helpers'

const ProtectedRoute = ({ component: Component, ...rest }) => {
  return (
    <Route {...rest} render={ props => isLoggedIn() ? 
      <Component {...props} /> : <Redirect to={{ pathname: "/login" }} />
    }
    />
  )
}

export default ProtectedRoute