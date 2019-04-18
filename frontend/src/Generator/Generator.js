import React, { Component } from 'react'

const { generatorApiUri } = require('../config')

class List extends Component {
  constructor (props) {
    super(props)

    this.state = {
      formOptions: {}
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
      .then(json => {
        const formOptions = json.data.map((formOption) => {
          return {}
        })

        this.setState({
          formOptions: formOptions
        })
      })
  }

  render () {

    return (
      <div>
        <h1>Generator</h1>
      </div>
    )
  }
}

export default List
