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
import 'semantic-ui-css/semantic.min.css'
import ProjectOptions from './ProjectOptions'
import {saveSync} from 'save-file'

import { Button, Form } from 'formik-semantic-ui'

const { generatorApiUri } = require('../config')

class Generator extends Component {
  constructor (props) {
    super(props)

    this.state = {
      formSchema: {},
      formData: {},
    }
  }

  submitProject (values) {
    console.log(values)

    const request = new Request(generatorApiUri, {
      method: 'POST',
      headers: new Headers(),
      body: JSON.stringify(values)
    })

    request.headers.append('accept', 'application/json')

    fetch(request)
      .then(response => {
        return response.json()
      })
      .then(json => {
        saveSync(json.base64Blob, json.filename)
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

  render () {
    return (
      <div>
        <h1>Generator</h1>

        <Form onSubmit={(values) => {
          this.submitProject(values)
        }}>
          <ProjectOptions schema={this.state.formSchema}/>


          <Button.Submit>Submit</Button.Submit>
        </Form>

        <hr/>
        <h2>Schema'd form</h2>
        <Form2 schema={this.state.formSchema}/>
      </div>
    )
  }
}

export default Generator
