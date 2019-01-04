import * as types from "./types"
import api from "../../utils/api"

export const saveUser = user => {
  return {
    type: types.SAVE_USER,
    user
  }
}

export const logout = () => {
  return {
    type: types.LOGOUT
  }
}

export const fetchBoards = () => dispatch => {
  api.get('/api/boards')
    .then(res => dispatch({
      type: types.FETCH_BOARDS,
      payload: res.data.items
    }))
}

export const fetchUsers = () => dispatch => {
  api.get('/api/users')
    .then(res => dispatch({
      type: types.FETCH_USERS,
      payload: res.data
    }))
}

export const createBoard = (board) => dispatch => {
  api.post('/api/boards', board)
    .then((response) => {
      dispatch({
        type: types.ADD_BOARD,
        payload: response.data
      })
    })
}

export const fetchListsByBoard = (boardId) => dispatch => {
  api.get(`/api/lists/board/${boardId}`)
    .then((response) => {
      dispatch({
        type: types.FETCH_LISTS,
        payload: response.data.items
      })
    })
}

export const updateTaskPosition = (taskId, task) => dispatch => {
  api.patch(`/api/tasks/${taskId}`, task)
}


export const toggleModal = (show) => {
  return {
    type: types.TOGGLE_MODAL,
    modal: show
  }
}

export const createList = (boardId, list) => dispatch => {
  api.post(`/api/lists/board/${boardId}`, list)
    .then((response) => {
      dispatch({
        type: types.ADD_LISTS,
        payload: response.data
      })
    })
}

export const createTask = (list, task) => dispatch => {
  api.post(`/api/tasks/lists/${list.id}`, task)
    .then((response) => {
      dispatch({
        type: types.ADD_TASK,
        payload: response.data
      })
    })
}


export const removeTask = (task) => dispatch => {
  api.delete(`/api/tasks/${task.id}`)
}
