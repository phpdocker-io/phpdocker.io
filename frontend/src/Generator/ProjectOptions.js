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
import { Input } from 'formik-semantic-ui'

class ProjectOptions extends Component {
  constructor (props) {
    super(props)

    this.state = {
      formData: {
        name: null,
        basePort: null,
      }
    }
  }

  componentDidMount () {
  }

  render () {
    const properties = this.props.schema.properties

    if (properties === undefined) {
      return null
    }

    return (
      <fieldset>
        <legend>Project options</legend>
        <Input
          name={'name'}
          label={properties.name.title}
          inputProps={{
            type: "text",
            placeholder: properties.name.attr.placeholder,
          }}
        />

        <Input
          name={'basePort'}
          label={properties.basePort.title}
          inputProps={{
            type: "number",
            placeholder: properties.basePort.attr.placeholder,
          }}
        />
      </fieldset>
    )
  }
}

export default ProjectOptions
