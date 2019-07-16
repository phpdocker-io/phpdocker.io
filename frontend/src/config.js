module.exports = {
  contentApiUri: process.env.REACT_APP_POST_API_URI || 'http://localhost:5002/content/posts',
  contactApiUri: process.env.REACT_APP_CONTACT_API_URI || 'http://localhost:5002/contact',
  generatorApiUri: process.env.REACT_APP_GENERATOR_API_URI || 'http://localhost:5002/generator'
}
