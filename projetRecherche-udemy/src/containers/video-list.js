import React from 'react'
import VideoListItem from '../components/video-list-item'

const VideoList = () => {
        const movies = ['movie1', 'movie2', 'movie3', 'movie4', 'movie5'];
    return (
        <div>
            <ul>
                {
                    movies.map(movie => {
                        return <VideoListItem movie={movie} />
                    })
                }
            </ul>
        </div>
    );

}

export default VideoList;