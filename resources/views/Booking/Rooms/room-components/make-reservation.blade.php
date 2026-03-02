<!-- Room reservation script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const makeReservationButton = document.getElementById("submit-btn");
        const providerId = {{ $room->providers_id }};
        console.log(`The provider Id is: ${providerId}`);

        makeReservationButton.addEventListener("click", function (event) {
            event.preventDefault();


            const reservedRoomIds = [];
            const numRooms = [];
            const checkinTime = document.getElementById('check_in_time').value;
            const checkoutTime = document.getElementById('check_out_time').value;
            console.log(`The check in time is: ${checkinTime}\nthe check out time is: ${checkoutTime}`)

            const roomId = {{$room->id}};
                
                

            reservedRoomIds.push(roomId);
            numRooms.push(1);
            console.log(`The reserved rooms is ${reservedRoomIds} \n the numRoom is ${roomId}`);
            // console.log(`The providerId is: ${providerId}`);

            if(checkinTime == '' || checkoutTime == ''){
                alert('Please select dates for your stay');
            }
            else if(checkinTime > checkoutTime)
            {
                alert('check out Time cannot be before check in time');    
            }
            else
            {
                if (reservedRoomIds.length > 0) {
                    // Redirect to the create booking page with room IDs and dates
                    const url = `/room_booking/create?room_ids=${reservedRoomIds.join(',')}&num_rooms=${numRooms.join(',')}&pid=${providerId}&check_in_time=${checkinTime}&check_out_time=${checkoutTime}`;
                    window.location.href = url;
                }
                else {
                    // Inform the user to select at least one room
                    alert("Please select at least one room to make a reservation.");
                }
            }
            
        });
    });
</script>