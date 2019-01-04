import React, { Component } from 'react'
import store from '../../../store'
import { createBoard, toggleModal } from "../../../store/actions"
import { getUser } from "../../../utils/helpers";

class BoardForm extends Component {
  constructor(props) {
    super(props)

    this.state = {
      users: [],
      name: '',
      description: ''
    }
    this.textInput = React.createRef();
  }

  onChange = (event) => {
    this.setState({ [event.target.name]: event.target.value })
  }

  onChangeUsers = (event) => {
    let users = [...this.state.users]

    users.push(event.target.value)

    users = [...new Set(users)]

    this.setState({
      users
    })
  }

  forceFocus = () =>{
    this.textInput.current.focus()
  }

  onSubmit = (event) => {
    event.preventDefault()

    const description = this.refs.description
    const board = {
      name: this.state.name,
      users: this.state.users,
      description: this.state.description
    }

    store.dispatch(createBoard(board))

    this.setState({
      name: '',
      users: [],
      description: ''
    })

    description.value = ''

    store.dispatch(toggleModal())
  }
  render() {
    const { users } = this.props
    const { name } = this.state

    const filteredUsers = users.filter((user) => {
      return user.id !== getUser().id
    })

    return (
      <form onSubmit={(event) => { this.onSubmit(event) }}>
        <div className="form-group">
          <label className="control-label">Board name:</label>
          <input type="text" name="name" value={name} className="form-control" onChange={(event) => { this.onChange(event) }} ref={this.textInput} required="required" />
        </div>
        <div className="form-group">
          <label className="control-label">Description:</label>
          <textarea type="text" name="description" className="form-control" ref="description" onChange={(event) => { this.onChange(event) }} />
        </div>
        <div className="form-group">
          <label className="control-label">Invite users:</label>
          <select name="users" className="form-control" onChange={(event) => { this.onChangeUsers(event) }}>
            <option value="">Choose users...</option>
            {filteredUsers.map((user) => {
              return <option key={user.id} value={user.id}>{user.email}</option>
            })}
          </select>
        </div>
        <div className="form-group text-right">
          <button type="submit" className="btn btn-primary">Create</button>
        </div>
      </form>
    )
  }
}
export default BoardForm