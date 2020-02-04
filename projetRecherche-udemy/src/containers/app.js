import React, { Component } from 'react'
import SearchBar from '../components/search-bar'
import VideoList from './video-list'

export default class App extends Component {
  render() {
    return (
      <div>
        <SearchBar />
        <VideoList />
      </div>
    ); 
  }
}
