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
import { Dropdown, Input, } from './controls/index'

import { enumToOptions } from './semanticUiTools'
import { randomRange } from '../util'

class ProjectOptions extends Component {
  /**
   * Returns a random port number between 2000 and 65000.
   *
   * Step is multiples of 1000 to make it easy to remember for someone generating a project here.
   *
   * @returns {number}
   */
  static randomPort () {
    return randomRange(2, 65) * 1000
  }

  render () {
    const properties = this.props.schema.properties

    if (properties === undefined) {
      return null
    }

    const appOptions     = properties.applicationOptions.properties
    const appTypeOptions = enumToOptions(appOptions.applicationType)
    const randomPort     = ProjectOptions.randomPort(1025, 32768)

    return (
      <fieldset>
        <legend>Project options</legend>
        <Form.Group widths={'equal'}>
          <Input
            fluid
            name={'name'}
            label={properties.name.title}
            inputProps={{
              type: 'text',
              placeholder: properties.name.attr.placeholder,
            }}
          />
          <Input
            fluid
            name={'basePort'}
            label={properties.basePort.title}
            inputProps={{
              type: 'number',
              defaultValue: randomPort,
            }}
          />
        </Form.Group>

        <Form.Group widths={'equal'}>
          <Dropdown
            name={'applicationOptions.applicationType'}
            label={appOptions.applicationType.title}
            options={appTypeOptions}
            inputProps={{
              defaultValue: appTypeOptions[0].value,
            }}
          />
          <Input
            name={'applicationOptions.uploadSize'}
            label={appOptions.uploadSize.title}
            inputProps={{
              type: 'number',
              defaultValue: 100,
            }}
          />
        </Form.Group>
      </fieldset>
    )
  }
}

export default ProjectOptions
