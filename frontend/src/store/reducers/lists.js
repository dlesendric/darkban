import { ADD_LISTS, ADD_TASK, FETCH_LISTS, DELETE_TASK } from "../actions/types"

const initialState = {
  items: [],
  list: {},
}

const replaceList = (lists, task) => {
  let newList = [...lists]
  newList.forEach(function (element) {
    if (element.id && element.id === task.list.id) {
      element.tasks.push(task)
    }
  })
  return newList
}

const removeTask = (lists, task) => {
  let newList = [...lists];
  newList.forEach(function(element){

    if(element.id && task.list && element.id === task.list.id){
      let index = element.tasks.indexOf(task);
      element.tasks.splice(index, 1);
    }
    if(element.id && task.list_id && element.id === task.list_id){
      let index = element.tasks.indexOf(task);
      element.tasks.splice(index, 1);
    }

  });
  return newList
}


export default function (state = initialState, action) {
  let newList = [];
  switch (action.type) {
    case FETCH_LISTS:
      return {
        ...state,
        items: action.payload,
      }
    case ADD_LISTS:
      return {
        ...state,
        list: action.payload
      }
    case ADD_TASK:
      newList = replaceList(state.items, action.payload)
      return {
        ...state,
        items: newList
      }
    case DELETE_TASK:
      newList = removeTask(state.items, action.payload);
      return {
        ...state,
        items:newList
      }
    default:
      return state
  }
}