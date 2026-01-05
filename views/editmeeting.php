<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
    <title>ReservationAPI - Edit meeting</title>
</head>

<body>
    <div class="vh-100 bg-dark d-flex justify-content-center align-items-center">
        <div class="bg-light p-4 rounded-3">
            <h3 class="fw-bold text-center text-dark">Meeting form editor</h3>
            <form action="/edit-meeting" method="post">
                <input type="hidden" value="<?= htmlspecialchars($meetingData['id']) ?>" name="id" id="id">
                <div class="form-group d-flex flex-column mt-2">
                    <label class="ms-2" for="meetingName">Meeting name</label>
                    <input class="form-control" type="text" value="<?= htmlspecialchars($meetingData['meetingName']) ?>" name="meetingName" id="meetingName" placeholder="Enter meeting name">
                </div>
                <div class="form-group d-flex flex-column mt-2">
                    <label class="ms-2" for="meetingPlace">Meeting place</label>
                    <input class="form-control" type="text" value="<?= htmlspecialchars($meetingData['meetingPlace']) ?>" name="meetingPlace" id="meetingPlace" placeholder="Enter meeting place">
                </div>
                <div class="form-group d-flex flex-column mt-2">
                    <label class="ms-2" for="meetingDate">Start meeting</label>
                    <input class="form-control" type="datetime-local" value="<?= (date('Y-m-d\TH:i', strtotime($meetingData['meetingDate']))) ?>" name="meetingDate" id="meetingDate" placeholder="Select date and time">
                </div>
                <button class="btn btn-success fw-bold w-100 mt-3" type="submit">Edit meeting</button>
            </form>
        </div>
    </div>
</body>

</html>