import React from 'react'

const VideoListItem = ({movie}) => {
    //({movie}) veut dire let movie = props.movie
    return <li>A recommended movie : {movie}</li>
}

export default VideoListItem;