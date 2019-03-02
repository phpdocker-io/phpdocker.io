import React, { Component } from 'react'
import { ErrorMessage, Field, Form, Formik } from 'formik'

const { contactApiUri } = require('./config')

class List extends Component {
  constructor (props) {
    super(props)

    this.state = {
      email: '',
      message: '',
    }
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

    this.setState({
      email,
      message,
    })

    if (result.status !== 200) {
      const response = await result.json()
      if (response.errors) {

        const firstErrors = response.errors.filter((value, key) => {
          return key === 0
        })

        const errors = {}

        for (let { property, description } of firstErrors) {
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
        <Formik
          initialValues={this.state}
          onSubmit={(values, actions) => {
            this.handleSubmit(values.email, values.message, actions).then(
              ok => {},
              errors => {
                actions.setSubmitting(false)
                actions.setErrors(errors)
                actions.setStatus({ msg: 'Set some arbitrary status or data' })
              })
          }}

          render={({ errors, status, touched, isSubmitting }) => (
            <Form>
              <Field type="email" component="input" name="email" placeholder="Your email"/>
              <ErrorMessage name="email">
                {errorMessage => <div className="error">{errorMessage}</div>}
              </ErrorMessage>

              <Field type="text" component="textarea" name="message"
                     placeholder="Feedback, recommendations, feature requests..."/>
              <ErrorMessage name="message">
                {errorMessage => <div className="error">{errorMessage}</div>}
              </ErrorMessage>

              <button type="submit" disabled={isSubmitting}>
                Send your message
              </button>
              <p>
                <strong>Privacy notice:</strong> this contact form sends an email to the website maintainer with your
                email address as
                reply-to, and obviously your message. Other than my email inbox, neither your email address nor your
                message are stored or logged anywhere else nor will they be used for anything other than replying back
                to you.
              </p>
            </Form>
          )}
        />
      </div>
    )
  }
}

export default List
