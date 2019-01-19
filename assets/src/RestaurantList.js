import React, {Component} from 'react';
import $ from 'jquery';
import Restaurant from './Restaurant';

class RestaurantList extends Component {

    isFavourite(favouriteRestaurants, restaurant) {
        if ($.inArray(restaurant.name, favouriteRestaurants) >= 0) {
            return true;
        }
        return false;
    }

    getRestaurantsComponent(restaurants, selectedSortCriteria, onFavouriteClick, favouriteRestaurantNames) {

        const allRestaurants = this.sortByIsFavourite(restaurants, favouriteRestaurantNames);

        return allRestaurants.map(function (restaurant, index) {
            const isFavourite = this.isFavourite(favouriteRestaurantNames, restaurant);
            return <Restaurant key={index} selectedSortCriteria={selectedSortCriteria} name={restaurant.name}
                               status={restaurant.status} features={restaurant.features}
                               onFavouriteClick={onFavouriteClick}
                               isFavourite={isFavourite}
            />
        }.bind(this))
    }

    sortByIsFavourite(restaurants, favouriteRestaurantNames) {
        const favouriteRestaurants = restaurants.filter(restaurant => {
            return this.isFavourite(favouriteRestaurantNames, restaurant);
        });

        const nonFavouriteRestaurants = restaurants.filter(restaurant => {
            return !this.isFavourite(favouriteRestaurantNames, restaurant);
        });
        const allRestaurants = favouriteRestaurants.concat(nonFavouriteRestaurants);
        return allRestaurants;
    }

    render() {
        return (
            <div className="restaurant-list col">
                {this.getRestaurantsComponent(this.props.restaurants, this.props.selectedSortCriteria, this.props.onFavouriteClick, this.props.favouriteRestaurants)}
            </div>
        );
    }

}

export default RestaurantList;
