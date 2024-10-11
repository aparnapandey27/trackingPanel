
function getChartColorsArray(chartId) {
    if (document.getElementById(chartId) !== null) {
        var colors = document.getElementById(chartId).getAttribute("data-colors");
        if (colors) {
            colors = JSON.parse(colors);
            return colors.map(function (value) {
                var newValue = value.replace(" ", "");
                if (newValue.indexOf(",") === -1) {
                    var color = getComputedStyle(document.documentElement).getPropertyValue(
                        newValue
                    );
                    if (color) return color;
                    else return newValue;
                } else {
                    var val = value.split(",");
                    if (val.length == 2) {
                        var rgbaColor = getComputedStyle(
                            document.documentElement
                        ).getPropertyValue(val[0]);
                        rgbaColor = "rgba(" + rgbaColor + "," + val[1] + ")";
                        return rgbaColor;
                    } else {
                        return newValue;
                    }
                }
            });
        } else {
            console.warn('data-colors atributes not found on', chartId);
        }
    }
}

// var linechartcustomerColors = getChartColorsArray("customer_impression_charts");
// if (linechartcustomerColors) {
//     var options = {
//         series: [{
//                 name: "Revenue",
//                 type: "area",
//                 data: data_revenue,
//             },
//             {
//                 name: "Profit",
//                 type: "bar",
//                 data: data_profit,
//             },
//             {
//                 name: "Payout",
//                 type: "line",
//                 data: data_payout,
//             },
//         ],
//         chart: {
//             height: 370,
//             type: "line",
//             toolbar: {
//                 show: false,
//             },
//         },
//         stroke: {
//             curve: "straight",
//             dashArray: [0, 0, 8],
//             width: [2, 0, 2.2],
//         },
//         fill: {
//             opacity: [0.1, 0.9, 1],
//         },
//         markers: {
//             size: [0, 0, 0],
//             strokeWidth: 2,
//             hover: {
//                 size: 4,
//             },
//         },
//         xaxis: {
//             categories: [
//                 "Jan",
//                 "Feb",
//                 "Mar",
//                 "Apr",
//                 "May",
//                 "Jun",
//                 "Jul",
//                 "Aug",
//                 "Sep",
//                 "Oct",
//                 "Nov",
//                 "Dec",
//             ],
//             axisTicks: {
//                 show: false,
//             },
//             axisBorder: {
//                 show: false,
//             },
//         },
//         grid: {
//             show: true,
//             xaxis: {
//                 lines: {
//                     show: true,
//                 },
//             },
//             yaxis: {
//                 lines: {
//                     show: false,
//                 },
//             },
//             padding: {
//                 top: 0,
//                 right: -2,
//                 bottom: 15,
//                 left: 10,
//             },
//         },
//         legend: {
//             show: true,
//             horizontalAlign: "center",
//             offsetX: 0,
//             offsetY: -5,
//             markers: {
//                 width: 9,
//                 height: 9,
//                 radius: 6,
//             },
//             itemMargin: {
//                 horizontal: 10,
//                 vertical: 0,
//             },
//         },
//         plotOptions: {
//             bar: {
//                 columnWidth: "30%",
//                 barHeight: "70%",
//             },
//         },
//         colors: linechartcustomerColors,
//         tooltip: {
//             shared: true,
//             y: [{
//                     formatter: function (y) {
//                         if (typeof y !== "undefined") {
//                             return y.toFixed(2);
//                         }
//                         return y;
//                     },
//                 },
//                 {
//                     formatter: function (y) {
//                         if (typeof y !== "undefined") {
//                             return  y.toFixed(2);
//                         }
//                         return y;
//                     },
//                 },
//                 {
//                     formatter: function (y) {
//                         if (typeof y !== "undefined") {
//                             return y.toFixed(2);
//                         }
//                         return y;
//                     },
//                 },
//             ],
//         },
//     };
//     var chart = new ApexCharts(
//         document.querySelector("#customer_impression_charts"),
//         options
//     );
//     chart.render();
// }

// Simple Donut Charts
// var chartDonutBasicColors = getChartColorsArray("store-visits-source");
// if (chartDonutBasicColors) {
//     var options = {
//         series: [44, 55, 41, 17],
//         labels: ["Android", "iPhone", "Laptop", "Other"],
//         chart: {
//             height: 333,
//             type: "donut",
//         },
//         legend: {
//             position: "bottom",
//         },
//         stroke: {
//             show: false
//         },
//         dataLabels: {
//             dropShadow: {
//                 enabled: false,
//             },
//         },
//         colors: chartDonutBasicColors,
//     };

//     var chart = new ApexCharts(
//         document.querySelector("#store-visits-source"),
//         options
//     );
//     chart.render();
// }

// world map with markers
// Your existing JavaScript code for getting chart colors
var vectorMapWorldMarkersColors = getChartColorsArray("sales-by-locations");

if (vectorMapWorldMarkersColors) {
    // Create an empty array to store markers
    var markers = [];

    // Access the JSON data from the hidden HTML element
    var countryDataElement = document.getElementById('countryData');
    if (countryDataElement) {
        var countryData = JSON.parse(countryDataElement.getAttribute('data-countries'));

        // Loop through the countryData and construct the markers array
        for (var i = 0; i < countryData.length; i++) {
            markers.push({
                name: countryData[i].Country,
                coords: [31.9474, 35.2272],
            });
        }

        // Your existing JavaScript code for creating the map
        var worldemapmarkers = new jsVectorMap({
            map: "world_merc",
            selector: "#sales-by-locations",
            zoomOnScroll: false,
            zoomButtons: false,
            selectedMarkers: [0, 5],
            regionStyle: {
                initial: {
                    stroke: "#9599ad",
                    strokeWidth: 0.25,
                    fill: vectorMapWorldMarkersColors[0],
                    fillOpacity: 1,
                },
            },
            markersSelectable: true,
            markers: markers, // Use the dynamically created 'markers' array
            markerStyle: {
                initial: {
                    fill: vectorMapWorldMarkersColors[1],
                },
                selected: {
                    fill: vectorMapWorldMarkersColors[2],
                },
            },
            labels: {
                markers: {
                    render: function (marker) {
                        return marker.name;
                    },
                },
            },
        });
    }
}


// Vertical Swiper
var swiper = new Swiper(".vertical-swiper", {
    slidesPerView: 2,
    spaceBetween: 10,
    mousewheel: true,
    loop: true,
    direction: "vertical",
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
});

var layoutRightSideBtn = document.querySelector('.layout-rightside-btn');
if (layoutRightSideBtn) {
    Array.from(document.querySelectorAll(".layout-rightside-btn")).forEach(function (item) {
        var userProfileSidebar = document.querySelector(".layout-rightside-col");
        item.addEventListener("click", function () {
            if (userProfileSidebar.classList.contains("d-block")) {
                userProfileSidebar.classList.remove("d-block");
                userProfileSidebar.classList.add("d-none");
            } else {
                userProfileSidebar.classList.remove("d-none");
                userProfileSidebar.classList.add("d-block");
            }
        });
    });
    window.addEventListener("resize", function () {
        var userProfileSidebar = document.querySelector(".layout-rightside-col");
        if (userProfileSidebar) {
            Array.from(document.querySelectorAll(".layout-rightside-btn")).forEach(function () {
                if (window.outerWidth < 1699 || window.outerWidth > 3440) {
                    userProfileSidebar.classList.remove("d-block");
                } else if (window.outerWidth > 1699) {
                    userProfileSidebar.classList.add("d-block");
                }
            });
        }
    });
    var overlay = document.querySelector('.overlay');
    if (overlay) {
        document.querySelector(".overlay").addEventListener("click", function () {
            if (document.querySelector(".layout-rightside-col").classList.contains('d-block') == true) {
                document.querySelector(".layout-rightside-col").classList.remove("d-block");
            }
        });
    }
}

window.addEventListener("load", function () {
    var userProfileSidebar = document.querySelector(".layout-rightside-col");
    if (userProfileSidebar) {
        Array.from(document.querySelectorAll(".layout-rightside-btn")).forEach(function () {
            if (window.outerWidth < 1699 || window.outerWidth > 3440) {
                userProfileSidebar.classList.remove("d-block");
            } else if (window.outerWidth > 1699) {
                userProfileSidebar.classList.add("d-block");
            }
        });
    }
});