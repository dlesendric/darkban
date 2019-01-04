import React, { Fragment } from 'react'

const EmptyPlaceholder = (props) => { 
    return (
      <Fragment>
      {
        props.items.length === 0 ?
          <div className={'empty_placeholder'}>
            <div className="empty_placeholder_text text-center">
              <i className="fa fa-plus-circle fa-3x mb-1" aria-hidden="true"></i>
              <p>{props.text}</p>
            </div>
          </div>
          : null
      }
      </Fragment>
    )
}

export default EmptyPlaceholder
