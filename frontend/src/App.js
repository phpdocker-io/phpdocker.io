import React, { Component } from 'react'
import List from './Posts/List'
import Generator from './Generator/Generator'
import Contact from './Contact'
import './App.css'
import 'semantic-ui-css/semantic.min.css'
import { Menu } from 'semantic-ui-react'
import { BrowserRouter as Router, Link, Route } from 'react-router-dom'

class App extends Component {
  state = {}
  handleItemClick = (e, { name }) => this.setState({ activeItem: name })

  render () {
    const { activeItem } = this.state

    return (
      <div>


        <Router>
          <div>
            <Menu>
              <Menu.Item
                as={Link} to="/"
                name='home'
                active={activeItem === 'home'}
                content='Home'
                onClick={this.handleItemClick}
              />

              <Menu.Item
                as={Link} to="/generator"
                name='generator'
                active={activeItem === 'generator'}
                content='Generator'
                onClick={this.handleItemClick}

              />

              <Menu.Item
                as={Link} to="/contact"
                name='contact'
                active={activeItem === 'Contact'}
                content='Contact'
                onClick={this.handleItemClick}
              />
            </Menu>

            <Route exact path="/" component={List}/>
            <Route path="/generator" component={Generator}/>
            <Route path="/contact" component={Contact}/>
          </div>
        </Router>
      </div>
    )
  }
}

export default App
