import { TOGGLE_MODAL } from "../actions/types"
import $ from 'jquery'

const toggleModal = (state) => {
  $(".modal").modal('toggle')
  return { ...state, modal: !state.modal }
}

const commonReducer = (modal = false, action) => {
  switch (action.type) {
    case TOGGLE_MODAL: return toggleModal(modal)

    default: return modal
  }
}

export default commonReducer