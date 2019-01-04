import React, { Fragment, Component } from 'react'
import store from "../../../../store"
import Dragula from 'react-dragula'
import classnames from 'classnames'
import { createTask, updateTaskPosition, removeTask } from "../../../../store/actions"
import TaskForm from "./TaskForm"

class Task extends Component {
  constructor(props) {
    super(props)

    this.containers = []
    this.state = {
      listId: null,
    }

    this.drake = null;
    this.tasksRefs = []
  }

  getIndexInParent = (el) => {
    return Array.from(el.parentNode.children).indexOf(el)
  }

  componentDidMount() {
    this.drake = Dragula(this.containers, {})
      .on('drop', (el, target) => {
        const parentId = target.parentNode.getAttribute('id')
        const itemId = el.getAttribute('data-id')
        const newItemPosition = this.getIndexInParent(el)

        let task = {
          list: parentId,
          sortNo: newItemPosition
        }

        store.dispatch(updateTaskPosition(itemId, task))
      })
  }

  setListId = (id) => {
    if (id !== null && id === this.state.listId) {
      id = null
    }

    this.setState({
      listId: id
    })
  }

  appendTask = (list, task) => {
    store.dispatch(createTask(list, task))

    this.setState({
      listId: null
    })
  }

  removeTask = (task) => {
    const taskToBeRemoved = document.getElementById(`task_${task.id}`)

    taskToBeRemoved.remove()
    store.dispatch(removeTask(task));
  }

  render() {
    const { listId } = this.state
    return (
      <Fragment>
        {
          this.props.lists.map((list) => {
            return (
              <div className="c-kanban__list" id={list.id} key={list.id}>
                <div className="c-kanban__list-header">
                  <h4>{list.name}</h4>
                </div>
                <div className="c-kanban__list-body" ref={this.dragulaDecorator}>
                  {list.tasks.map((task) => {
                    return (
                      <div className="c-kanban__item" key={'task' + task.id} id={`task_${task.id}`} data-id={task.id}>
                        {task.name}
                        <button type="button" className="btn btn-delete pull-right" onClick={() => { this.removeTask(task) }}><i className="fa fa-trash"></i></button>
                      </div>)
                  })}
                </div>
                <div className="c-kanban__list-footer">
                  <button className="btn btn-primary mt-2" onClick={() => { this.setListId(list.id) }}><i className="fa fa-plus-circle" aria-hidden="true"></i> Create new task</button>
                </div>
                <TaskForm
                  submitHandler={this.appendTask}
                  parentList={list}
                  list={list.id}
                  sortNo={list.tasks.length}
                  className={classnames({
                    'd-none': listId !== list.id
                  })}
                />
              </div>
            )
          })
        }
      </Fragment>
    )
  }

  dragulaDecorator = (componentBackingInstance) => {
    if (componentBackingInstance) {
      this.containers.push(componentBackingInstance)
    }
  }

}

export default Task
