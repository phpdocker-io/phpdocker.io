import React, { Component } from 'react'

const { contentApiUri } = require('../config')

class List extends Component {
  constructor (props) {
    super(props)

    this.state = {
      posts: []
    }
  }

  componentDidMount () {
    const request = new Request(contentApiUri, {
      method: 'GET',
      headers: new Headers()
    })

    // Request JSONAPI format
    request.headers.append('accept', 'application/vnd.api+json')

    fetch(request)
      .then(response => {
        return response.json()
      })
      .then(json => {
        const posts = json.data.map((post) => {
          const attributes = post.attributes

          return {
            title: attributes.title,
            bodyIntro: attributes.bodyIntro,
            slug: attributes.slug,
          }
        })

        this.setState({
          posts: posts
        })
      })
  }

  news () {
    let posts = []

    this.state.posts.map(post => {
      return posts.push(
        <div className="post" key={post.slug}>
          <h2>{post.title}</h2>
          <div>{post.bodyIntro}</div>
        </div>
      )
    })

    return posts
  }

  render () {

    return (
      <div>
        <h1>News</h1>
        {this.news()}
      </div>
    )
  }
}

export default List
