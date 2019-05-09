/*
 * Copyright 2019 Luis Alberto Pabón Flores
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

import React, { Component } from 'react'
import Form2 from 'react-jsonschema-form'
import { saveSync } from 'save-file'
import { Button, Form } from 'semantic-ui-react'
import { Formik } from 'formik'

import ProjectOptions from './ProjectOptions'
import ZeroConfigServiceOptions from './ZeroConfigServiceOptions'
import MySQLCompatibleOptions from './MySQLCompatibleOptions'

import 'semantic-ui-css/semantic.min.css'
import './generator.css'

import { randomRange } from '../util'

const { generatorApiUri } = require('../config')

class Generator extends Component {
  constructor (props) {
    super(props)

    this.state = {
      formSchema: {},
    }
  }

  handleRequestErrors = (response, formik) => {
    if (response.ok) {
      return response.json()
    }

    if (response.status === 400) {
      response.json()
        .then(json => {
          json.errors.forEach(error => {
            formik.setFieldError(error.property, error.description)
          })

          formik.setSubmitting(false)
        })
    }

    throw Error('Failed to generate project due to errors in the request')
  }

  handleRequestSuccess = (json, formik) => {
    saveSync(json.base64Blob, json.filename)
    formik.setSubmitting(false)
  }

  submitProject = (values, formik) => {
    const request = new Request(generatorApiUri, {
      method: 'POST',
      headers: new Headers(),
      body: JSON.stringify(values)
    })

    request.headers.append('accept', 'application/json')

    fetch(request)
      .then(response => {
        return this.handleRequestErrors(response, formik)
      })
      .then(json => {
        this.handleRequestSuccess(json, formik)
      })
      .catch(error => {
        console.error(error.message)
      })
  }

  componentDidMount () {
    const request = new Request(generatorApiUri, {
      method: 'GET',
      headers: new Headers()
    })

    request.headers.append('accept', 'application/json')

    fetch(request)
      .then(response => {
        return response.json()
      })
      .then(schema => {
        this.setState({
          formSchema: schema
        })
      })
  }

  renderForm = ({ handleSubmit, handleReset, isSubmitting }) => (
    <Form onSubmit={handleSubmit}>

      <ProjectOptions schema={this.state.formSchema}/>
      <ZeroConfigServiceOptions schema={this.state.formSchema}/>
      <MySQLCompatibleOptions schema={this.state.formSchema} schemaNode={'mysqlOptions'}/>

      <Button type="submit" loading={isSubmitting} primary>
        Submit
      </Button>
    </Form>
  )

  /*
   * @todo: find a way to do default values properly. Setting these here as using the input props
   *   doesn't seem to trigger setFieldValue in Formik.
   */
  render () {
    return (
      <div>
        <h1>Generator</h1>

        <Formik
          onSubmit={this.submitProject}
          render={this.renderForm}
          initialValues={{
            basePort: randomRange(2, 65) * 1000,
            applicationOptions: {
              applicationType: 'generic',
              uploadSize: 100,
            },
            mysqlOptions: {
              version: '8.0'
            }
          }}
        />

        <hr/>
        <h2>Schema'd form</h2>
        <Form2 schema={this.state.formSchema}/>
      </div>
    )
  }
}

export default Generator
