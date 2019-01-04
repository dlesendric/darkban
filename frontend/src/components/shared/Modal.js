import React, { Component } from 'react'
import store from "../../store"
import {toggleModal} from "../../store/actions"

class Modal extends Component {

  handleCloseClick = () => {
    store.dispatch(toggleModal)
  }

  render() {
    const { title, children } = this.props

    return (
      <div className="modal" tabIndex="-1" role="dialog" id="#modal">
        <div className="modal-dialog" role="document">
          <div className="modal-content">
            <div className="modal-header">
              <h5 className="modal-title">{title}</h5>
              <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div className="modal-body">
              { children }
            </div>
            <div className="modal-footer">
              <button type="button" className="btn btn-secondary" data-dismiss="modal" onClick={this.handleCloseClick}>Cancel</button>
            </div>
          </div>
        </div>
      </div>
    )
  }
}

export default Modal
