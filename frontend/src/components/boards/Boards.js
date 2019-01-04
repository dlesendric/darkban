import React, { Component, Fragment } from 'react'
import Navigation from '../shared/Navigation'
import Board from './board/Board'
import { connect } from 'react-redux'
import { fetchBoards, fetchUsers, createBoard, toggleModal } from "../../store/actions"
import PropTypes from 'prop-types'
import Modal from "../shared/Modal"
import EmptyPlaceholder from "../shared/EmptyPlaceholder"
import BoardForm from './board/BoardForm'
import store from '../../store'

class Boards extends Component {
  constructor(props) {
    super(props)
    this.state = {
      showModal: false
    }
    this.boardFormRef = React.createRef()
  }

  componentWillReceiveProps(nextProps, nextContext) {
    if (Object.keys(nextProps.newBoard).length > 0) {
      this.props.boards.unshift(nextProps.newBoard)
    }
  }

  componentDidMount() {
    this.props.fetchBoards()
    this.props.fetchUsers()
  }

  toggleModal = () => {
    store.dispatch(toggleModal(!store.modal))
    this.boardFormRef.current.forceFocus();
  }

  render() {
    const { boards, users } = this.props

    return (
      <Fragment>
        <EmptyPlaceholder
          items={boards}
          text={'There is no boards. You should create one! :)'} />
        <Navigation />
        <main className="c-boards">
          <div className="container">
            <div className="text-right">
              <button type="button" className="btn btn-primary mt-2" onClick={() => this.toggleModal()}><i className="fa fa-plus-circle" aria-hidden="true"></i> New Board</button>
            </div>
            <div className="row mt-3">
              {boards.map((board) => {
                return <Board
                  key={board.id}
                  id={board.id}
                  totalTasks={board.totalTasks}
                  totalLists={board.totalLists}
                  description={board.description}
                  name={board.name}
                  createdAt={board.createdAt}
                />
              })}
            </div>

          </div>
          <Modal title="Create new board">
            <BoardForm users={users} ref={this.boardFormRef} />
          </Modal>
        </main>
      </Fragment>
    )
  }
}

Boards.defaultProps = {
  boards: []
}
Boards.propTypes = {
  fetchUsers: PropTypes.func.isRequired,
  fetchBoards: PropTypes.func.isRequired,
  createBoard: PropTypes.func.isRequired,
  boards: PropTypes.array.isRequired,
  users: PropTypes.array,
  newBoard: PropTypes.object
}
const mapStateToProps = state => ({
  boards: state.boards.items,
  users: state.users.users,
  newBoard: state.boards.board
})


export default connect(mapStateToProps, { fetchBoards, fetchUsers, createBoard })(Boards)