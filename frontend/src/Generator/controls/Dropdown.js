/*
 * Lifted from https://github.com/justinobney/formik-semantic-ui-example
 */

import React, { Component } from 'react'
import { Dropdown, Form } from 'semantic-ui-react'
import { Field } from 'formik'

const dot = require('dot-object')

let fieldCounter = 0

class FormikDropdown extends Component {
  constructor (props) {
    super(props)
    this.id = props.id || `field_dropdown_${fieldCounter++}`
  }

  render () {
    const {
            name,
            label,
            options,
            inputProps = {},
            fieldProps = {}
          } = this.props
    return (
      <Field
        name={name}
        render={({ field, form }) => {
          // Even though formik serialises correctly dot notation, setFieldError creates objects - work around
          const dotErrors = dot.dot(form.errors)
          const error     = dotErrors[name]

          return (
            <Form.Field error={!!error} {...fieldProps}>
              {!!label && (
                <label htmlFor={this.id} onClick={() => this._dropdown.open()}>
                  {label}
                </label>
              )}
              <Dropdown
                ref={el => (this._dropdown = el)}
                id={this.id}
                name={name}
                options={options}
                selectOnBlur={false}
                selectOnNavigation={false}
                selection
                {...inputProps}
                value={field.value}
                onChange={(e, { name, value }) => {
                  form.setFieldValue(name, value, true)
                }}
              />
              {error && (
                <span
                  style={{
                    display: 'block',
                    margin: '.28571429rem 0',
                    color: 'rgb(159, 58, 56)',
                    fontSize: '.92857143em'
                  }}
                >
                    {error}
                  </span>
              )}
            </Form.Field>
          )
        }}
      />
    )
  }
}

export default FormikDropdown
