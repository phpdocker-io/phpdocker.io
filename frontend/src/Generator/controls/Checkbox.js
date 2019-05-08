/*
 * Lifted from https://github.com/justinobney/formik-semantic-ui-example
 */

import React, { Component } from 'react'
import { Checkbox, Form } from 'semantic-ui-react'
import { Field } from 'formik'
const dot = require('dot-object')

let fieldCounter = 0

class FormikCheckbox extends Component {
  constructor (props) {
    super(props)
    this.id = props.id || `field_checkbox_${fieldCounter++}`
  }

  render () {
    const { name, label, inputProps = {}, fieldProps = {} } = this.props
    return (
      <Field
        name={name}
        render={({ field, form }) => {
          // Even though formik serialises correctly dot notation, setFieldError creates objects - work around
          const dotErrors = dot.dot(form.errors)
          const error = dotErrors[name]

          return (
            <Form.Field error={!!error} {...fieldProps}>
              <Checkbox
                id={this.id}
                name={name}
                label={label}
                checked={field.value}
                onChange={(e, { name, checked }) => {
                  form.setFieldValue(name, checked, true)
                }}
                {...inputProps}
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

export default FormikCheckbox
