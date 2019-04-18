import React, { Component } from 'react'
import Form from 'react-jsonschema-form'
import 'semantic-ui-css/semantic.min.css'


const { generatorApiUri } = require('../config')

class List extends Component {
  constructor (props) {
    super(props)

    this.state = {
      formSchema: {}
    }
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
        <Form schema={this.state.formSchema}/>
      </div>
    )
  }
}

export default List
