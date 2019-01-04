import React, { Fragment, Component } from 'react'
import PropTypes from 'prop-types'
import classnames from 'classnames'

class TaskForm extends Component {
  constructor(props) {
    super(props)
    this.state = {
      name: ''
    }
  }

  onSubmit = (e) => {
    e.preventDefault();

    const { list, submitHandler, sortNo, parentList } = this.props
    const { name } = this.state;

    const task = {
      list: list,
      name: name,
      sortNo: sortNo
    };

    submitHandler(parentList, task);

    this.setState({
      name: '',
    })
  }

  onChange = (e) => {
    this.setState({
      [e.target.name]: e.target.value
    })
  }

  render() {
    const formClass = this.props.className
    const { name } = this.state

    return (
      <Fragment>
        <form className={classnames(`${formClass} mt-3`)} onSubmit={(event) => { this.onSubmit(event) }}>
          <div className="form-group">
            <label className="control-label">Task name</label>
            <input type="text" className="form-control" placeholder="Task name..." name="name" value={name} onChange={(e) => { this.onChange(e) }} />
          </div>
          <div className="form-group text-right">
            <button type="submit" className="btn btn-primary btn-sm">Submit</button>
          </div>
        </form>
      </Fragment>
    )
  }
}

TaskForm.propTypes = {
  className: PropTypes.string.isRequired,
}

export default TaskForm
