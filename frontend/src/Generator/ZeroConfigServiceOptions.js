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

import { Checkbox } from './controls/index'

class ZeroConfigServiceOptions extends Component {
  render () {
    const properties = this.props.schema.properties

    if (properties === undefined) {
      return null
    }

    return (
      <fieldset>
        <legend>Zero-config services</legend>
        <Form.Group widths={'equal'}>
          <Checkbox
            name={'hasRedis'}
            label={properties.hasRedis.title}
            inputProps={{
              toggle: true,
            }}
          />

          <Checkbox
            name={'hasMemcached'}
            label={properties.hasMemcached.title}
            inputProps={{
              toggle: true,
            }}
          />
        </Form.Group>

        <Form.Group widths={'equal'}>
          <Checkbox
            name={'hasMailhog'}
            label={properties.hasMailhog.title}
            inputProps={{
              toggle: true,
            }}
          />

          <Checkbox
            name={'hasClickhouse'}
            label={properties.hasClickhouse.title}
            inputProps={{
              toggle: true,
            }}
          />
        </Form.Group>
      </fieldset>
    )
  }
}

export default ZeroConfigServiceOptions
