import React, { Fragment, Component } from 'react'

import Navigation from '../../shared/Navigation'
import { connect } from "react-redux"
import { fetchListsByBoard, toggleModal } from "../../../store/actions"
import Task from './task/Task'
import Modal from "../../shared/Modal";
import EmptyPlaceholder from "../../shared/EmptyPlaceholder";
import ListsForm from "./lists/ListsForm";
import store from "../../../store";
import LinearLoader from "../../shared/LinearLoader";
import classnames from 'classnames';
class ViewBoard extends Component {

  constructor(props) {
    super(props);
    this.state = {
      loader: true,
    }

    this.listFormRef = React.createRef()
  }

  componentDidMount() {
    const { match: { params } } = this.props

    this.props.fetchListsByBoard(params.id)
  }

  toggleModal = () => {
    store.dispatch(toggleModal(!store.modal))

    this.listFormRef.current.forceFocus()
  }

  componentWillReceiveProps(nextProps, nextContext) {
    if (nextProps.lists) {
      this.setState({
        loader: false,
        showWelcome: nextProps.lists.length === 0
      })
    }
    if (Object.keys(nextProps.newList).length > 0) {
      this.props.lists.push(nextProps.newList)
    }
  }

  render() {
    const { lists, match: { params } } = this.props
    const { loader } = this.state

    return (
      <Fragment>
        <EmptyPlaceholder 
          items={lists} 
          text={'There is no lists in this board. You should create one! :)'} />
        <Navigation />
        <main>
          <div className="container">
            <div className="text-right">
              <button className="btn btn-primary mt-2 mb-2" onClick={() => this.toggleModal()}><i className="fa fa-plus-circle" aria-hidden="true"></i> Create new list</button>
            </div>
            {loader ? <LinearLoader /> : null}
          </div>
          <div className={classnames(['c-kanban', 'container-fluid'], { 'd-none': loader })}>
            <Task lists={lists} />
          </div>
          <Modal title="Create new list">
            <ListsForm ref={this.listFormRef} boardId={params.id} />
          </Modal>
        </main>
      </Fragment >
    )
  }
}

ViewBoard.defaultProps = {
  lists: [],
  newList: {}
}

const mapStateToProps = state => ({
  lists: state.lists.items,
  newList: state.lists.list
})

export default connect(mapStateToProps, { fetchListsByBoard })(ViewBoard)