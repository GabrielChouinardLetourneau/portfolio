import React, { Component } from 'react';
import SearchBar from '../components/search-bar';
import VideoList from './video-list';
import VideoDetail from '../components/video-detail';
import Video from '../components/video';
import axios from 'axios';

const API_END_POINT = 'https://api.themoviedb.org/3/';
const SEARCH_URL = 'search/movie?sort_by=popularity.desc';
const POPULAR_MOVIES_URL = 'discover/movie?sort_by=popularity.desc';
const API_KEY = 'api_key=448689459dc76da6251624edaee01113';

export default class App extends Component {
    constructor(props) {
        super(props);
        this.state = {
            movieList: {},
            currentMovie: {}
        };
    }
    componentWillMount() {
        this.initMovies();
    }
    initMovies() {
        axios.get(`${API_END_POINT}${POPULAR_MOVIES_URL}&${API_KEY}`).then(
            function(response) {
                this.setState(
                    {
                        movieList: response.data.results.slice(1, 6),
                        currentMovie: response.data.results[0]
                    },
                    function() {
                        this.applyVideoToCurrentMovie();
                    }
                );
            }.bind(this)
        );
    }
    applyVideoToCurrentMovie() {
        axios.get(`${API_END_POINT}movie/${this.state.currentMovie.id}?${API_KEY}&append_to_response=videos`).then(
            function(response) {
                console.log(response);

                const youtubeKey = response.data.videos.results[0].key;
                let newCurrentMovieState = this.state.currentMovie;
                newCurrentMovieState.videoId = youtubeKey;

                this.setState({
                    currentMovie: newCurrentMovieState
                });
            }.bind(this)
        );
    }

    setRecommendation() {
        axios.get(`${API_END_POINT}movie/${this.state.currentMovie.id}/recommendations?${API_KEY}`).then(
            function(response) {
                this.setState(
                    {
                        movieList: response.data.results.slice(0, 5)
                        // currentMovie: response.data.results[0]
                    },
                    function() {
                        this.applyVideoToCurrentMovie();
                    }
                );
            }.bind(this)
        );
    }

    onClickListItem(movie) {
        this.setState({ currentMovie: movie }, function() {
            this.applyVideoToCurrentMovie();
            this.setRecommendation();
        });
    }

    onClickSearch(searchText) {
        if (searchText) {
            console.log('fewfewf');
            axios.get(`${API_END_POINT}${SEARCH_URL}&${API_KEY}&query=${searchText}`).then(
                function(response) {
                    if (response.data && response.data.results[0]) {
                        if (response.data.results[0].id !== this.state.currentMovie.id) {
                            this.setState(
                                {
                                    currentMovie: response.data.results[0]
                                },
                                () => {
                                    if (this.state.currentMovie.videos) {
                                        this.applyVideoToCurrentMovie();
                                    }
                                    this.setRecommendation();
                                }
                            );
                        }
                    }
                }.bind(this)
            );
        }
    }

    render() {
        const renderVideoList = () => {
            if (this.state.movieList.length >= 5) {
                return <VideoList movieList={this.state.movieList} callback={this.onClickListItem.bind(this)} />;
            }
        };
        return (
            <div>
                <div className='search_bar'>
                    <SearchBar callback={this.onClickSearch.bind(this)} />
                </div>{' '}
                <div className='row'>
                    <div className='col-md-8'>
                        <Video videoId={this.state.currentMovie.videoId} />{' '}
                        <VideoDetail
                            title={this.state.currentMovie.title}
                            description={this.state.currentMovie.overview}
                        />{' '}
                    </div>{' '}
                    <div className='col-md-4'> {renderVideoList()} </div>{' '}
                </div>{' '}
            </div>
        );
    }
}
