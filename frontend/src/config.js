module.exports = {
  contentApiUri: process.env.POST_API_URI || 'http://localhost:5002/content/posts',
  contactApiUri: process.env.CONTACT_API_URI || 'http://localhost:5002/contact'
}
