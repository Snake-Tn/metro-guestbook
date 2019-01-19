import React from 'react';

function Restaurant(props) {

    function mapStatusToBadge(status) {
        switch (status) {
            case "closed":
                return "danger";
            case "open":
                return "success"
            default:
                return "primary"
        }
    }

    function mapIsFavouriteToColor(isFavourite) {
        if (isFavourite) {
            return 'danger'
        }
        return 'secondary';
    }

    function getFeatureValue(features, featureCode) {
        for (let i = 0; i < features.length; i++) {
            if (features[i].code === featureCode) {
                return features[i].value;
            }
        }
    }

    return <div className="list-group-item">
        <div className="container">
            <div className="row ">
                <div className="col-lg-5">
                    {props.name}
                </div>
                <div className="col-lg-2">
                    <span className={"badge badge-pill badge-" + mapStatusToBadge(props.status)}>{props.status}</span>
                </div>
                <div className="col-lg-4">
                    <span>{props.selectedSortCriteria}
                        : {getFeatureValue(props.features, props.selectedSortCriteria)}</span>
                </div>
                <div className="col-1">
                    <button onClick={props.onFavouriteClick.bind(null, props.name)} type="button"
                            className={"favourite btn btn-" + mapIsFavouriteToColor(props.isFavourite)}>&#10084;</button>
                </div>
            </div>
        </div>
    </div>;

}

export default Restaurant;