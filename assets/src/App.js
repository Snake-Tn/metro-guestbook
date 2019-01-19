import React, {Component} from 'react';
import RestaurantList from "./RestaurantList";
import SortBy from "./SortBy";
import SearchInput from "./SearchInput";
import request from 'request';
import "./App.css";
import $ from 'jquery';

class App extends Component {

    constructor(props) {
        super(props);
        this.onRestaurantSetAsFavourite = this.onRestaurantSetAsFavourite.bind(this);
        this.onSortCriteriaChange = this.onSortCriteriaChange.bind(this);
        this.onSearchInputChange = this.onSearchInputChange.bind(this);
    }

    state = {
        restaurants: [],
        sortCriteriaList: [],
        keyword: '',
        selectedSortCriteria: 'bestMatch',
        favouriteRestaurants: []
    };

    onRestaurantSetAsFavourite(favouriteRestaurant) {
        let favouriteRestaurants = this.state.favouriteRestaurants;
        if ($.inArray(favouriteRestaurant, favouriteRestaurants) >= 0) {
            favouriteRestaurants.splice($.inArray(favouriteRestaurant, favouriteRestaurants), 1);
        } else {
            favouriteRestaurants.push(favouriteRestaurant);
        }
        this.setState({favouriteRestaurants: favouriteRestaurants});

        localStorage.favouriteRestaurants = JSON.stringify(favouriteRestaurants);
    }

    onSortCriteriaChange(e) {
        const sortCriteria = e.target.value;
        this.refreshRestaurantList(this.state.keyword, sortCriteria);
        this.setState({selectedSortCriteria: sortCriteria});
    }

    onSearchInputChange(e) {
        const keyword = e.target.value;
        this.refreshRestaurantList(keyword, this.state.selectedSortCriteria);
        this.setState({keyword: keyword});
    }

    componentDidMount() {
        this.refreshRestaurantList(this.state.keyword, this.state.selectedSortCriteria);
        this.initializeSortCriteriaList();
        this.initializeFavouriteRestaurant()
    }

    refreshRestaurantList(keyword, sortCriteria) {
        request(
            'http://local.metro-guestbook:8001/api/restaurants?keyword=' +
            encodeURIComponent(keyword.trim()) +
            '&sortby=' + encodeURIComponent(sortCriteria)
            , function (error, response, body) {
                this.setState({restaurants: JSON.parse(body)});
            }.bind(this));
    }

    initializeSortCriteriaList() {
        request('http://local.metro-guestbook:8001/api/sort-criteria', function (error, response, body) {
            this.setState({sortCriteriaList: JSON.parse(body)});
        }.bind(this));
    }

    initializeFavouriteRestaurant() {
        if (localStorage.favouriteRestaurants) {
            this.setState({favouriteRestaurants: JSON.parse(localStorage.favouriteRestaurants)});
        }
    }

    render() {
        return (
            <div className="search container-fluid">
                <div className="row justify-content-center">
                    <div className="col">
                        <div className="row">
                            <SearchInput onChange={this.onSearchInputChange}/>
                            <SortBy sortCriteriaList={this.state.sortCriteriaList}
                                    onChange={this.onSortCriteriaChange}/>
                        </div>
                        <div className="row">
                            <RestaurantList onFavouriteClick={this.onRestaurantSetAsFavourite}
                                            restaurants={this.state.restaurants}
                                            selectedSortCriteria={this.state.selectedSortCriteria}
                                            favouriteRestaurants={this.state.favouriteRestaurants}
                            />
                        </div>
                    </div>
                </div>
            </div>
        );
    }

}

export default App;
