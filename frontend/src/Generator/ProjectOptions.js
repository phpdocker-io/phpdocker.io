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
import { Form } from 'semantic-ui-react'
import { enumToOptions } from './semanticUiTools'

class ProjectOptions extends Component {
  constructor (props) {
    super(props)

    this.state = {}
  }

  componentDidMount () {
  }

  static randomRange (min, max) {
    return ~~(Math.random() * (max - min + 1)) + min
  }

  render () {
    const properties = this.props.schema.properties

    if (properties === undefined) {
      return null
    }

    const appOptions     = properties.applicationOptions.properties
    const appTypeOptions = enumToOptions(appOptions.applicationType)
    const randomPort     = ProjectOptions.randomRange(1025, 32768)

    return (
      <fieldset>
        <legend>Project options</legend>
        <Form.Group widths={'equal'}>
          <Form.Input
            fluid
            name={'name'}
            label={properties.name.title}
            type={'text'}
            placeholder={properties.name.attr.placeholder}
          />
          <Form.Input
            fluid
            name={'basePort'}
            label={properties.basePort.title}
            type={'number'}
            placeholder={properties.basePort.attr.placeholder}
            defaultValue={randomPort}
          />
        </Form.Group>

        <Form.Group widths={'equal'}>
          <Form.Select
            name={'applicationOptions.applicationType'}
            label={appOptions.applicationType.title}
            options={appTypeOptions}
            defaultValue={appTypeOptions[0].value}
          />
          <Form.Input
            name={'applicationOptions.uploadSize'}
            label={appOptions.uploadSize.title}
            type={'number'}
            defaultValue={100}
          />
        </Form.Group>
      </fieldset>
    )
  }
}

export default ProjectOptions
