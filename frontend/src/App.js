import React, { Component } from 'react'
import List from './Posts/List'
import './App.css'
import 'semantic-ui-css/semantic.min.css'

class App extends Component {

  render () {

    return (
      <div>
        <List/>
      </div>
    )
  }
}

export default App
