import React, { Component } from 'react'
import store from "../../../../store";
import { createList, toggleModal } from "../../../../store/actions";

class ListsForm extends Component {
  constructor(props) {
    super(props)
    this.state = {
      name: ''
    }

    this.textInput = React.createRef();
  }

  onChange = (event) => {
    this.setState({ [event.target.name]: event.target.value })
  }

  forceFocus = () =>{
    this.textInput.current.focus()
  }

  onSubmit = (event) => {
    event.preventDefault()

    const { boardId } = this.props
    const list = {
      name: this.state.name,
      sortNo: 0
    };

    store.dispatch(createList(boardId, list))

    this.setState({
      name: '',
    })

    store.dispatch(toggleModal())
  }
  render() {
    const { name } = this.state

    return (
      <form onSubmit={(event) => { this.onSubmit(event) }}>
        <div className="form-group">
          <label className="control-label">List name:</label>
          <input ref={this.textInput} type="text" value={name} placeholder="List name..." className="form-control" name="name" onChange={(event) => { this.onChange(event) }} />
        </div>
        <div className="form-group text-right">
          <button type="submit" className="btn btn-primary">Create</button>
        </div>
      </form>
    )
  }
}

export default ListsForm
