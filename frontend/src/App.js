import React, { Component } from 'react'
import List from './Posts/List'
import Generator from './Generator/Generator'
import Contact from './Contact'
import './App.css'
import 'semantic-ui-css/semantic.min.css'
import { BrowserRouter as Router, Route, Link } from "react-router-dom";

class App extends Component {

  render () {
    return (
      <div>

        <Router>
          <div>
            <ul>
              <li>
                <Link to="/">Home</Link>
              </li>
              <li>
                <Link to="/generator">Generator</Link>
              </li>
              <li>
                <Link to="/contact">Contact</Link>
              </li>
            </ul>

            <hr />

            <Route exact path="/" component={List} />
            <Route path="/generator" component={Generator} />
            <Route path="/contact" component={Contact} />
          </div>
        </Router>
      </div>
    )
  }
}

export default App
