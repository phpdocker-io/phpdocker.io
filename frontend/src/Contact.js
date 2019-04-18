import React, { Component } from 'react'
import { Button, Form } from 'formik-semantic-ui'

const { contactApiUri } = require('./config')
g
class List extends Component {
  constructor (props) {
    super(props)

    this.state = {}
  }

  componentDidMount () {

  }

  handleSubmit = async (email, message) => {
    const result = await fetch(contactApiUri, {
      method: 'POST',
      headers: {
        'content-type': 'application/json',
      },
      body: JSON.stringify({
        email,
        message
      })
    })

    if (result.status !== 200) {
      const response = await result.json()
      if (response.errors) {
        const errors = {}

        for (let { property, description } of response.errors) {
          errors[property] = description
        }

        throw errors
      }

      return true
    }
  }

  render () {

    return (
      <div>
        <h1>Contact</h1>
        <Form
          onSubmit={(values, actions) => {
            this.handleSubmit(values.email, values.message, actions).then(
              ok => {},
              errors => {
                actions.setSubmitting(false)
                actions.setErrors(errors)
                actions.setStatus({ msg: 'Set some arbitrary status or data' })
              })
          }}

          schema={{
            email: {
              inputProps: {
                placeholder: 'Your email',
              },
              type: 'text',
            },
            message: {
              type: 'textarea',
              inputProps: {
                placeholder: 'Feedback, recommendations, feature requests...',
              }
            }
          }}
        >

          <Button.Submit>Send your message</Button.Submit>

          <p>
            <strong>Privacy notice:</strong> this contact form sends an email to the website maintainer with your
            email address as
            reply-to, and obviously your message. Other than my email inbox, neither your email address nor your
            message are stored or logged anywhere else nor will they be used for anything other than replying back
            to you.
          </p>
        </Form>
      </div>
    )
  }
}

export default List
