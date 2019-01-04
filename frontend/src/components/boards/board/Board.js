import React from 'react'
import PropTypes from 'prop-types'
import { Link } from 'react-router-dom'
import moment from 'moment'

const Board = (props) => {
  const { id, name, createdAt, description, totalTasks, totalLists } = props;

  return (
    <div className="col-sm-12 col-md-3 mb-3">
      <div className="card">
        <div className="card-body">
          <h5 className="card-title">{name}</h5>
          <p className="card-text card-description">{description}</p>
          <p className="card-text card-number-of-lists">Number of lists: (<strong>{totalLists}</strong>)</p>
          <p className="card-text card-number-of-tasks">Number of tasks: (<strong>{totalTasks}</strong>)</p>
          <p className="card-text card-date">Created: <strong>{moment(createdAt).fromNow()}</strong></p>
          <Link to={`board/${id}`} className="btn btn-primary">View board <i className="fa fa-chevron-circle-right" aria-hidden="true"></i></Link>
        </div>
      </div>
    </div>
  )
}

Board.propTypes = {
  name: PropTypes.string.isRequired,
  createdAt: PropTypes.string.isRequired,
  description: PropTypes.string,
  totalLists: PropTypes.number,
  totalTasks: PropTypes.number
}

export default Board