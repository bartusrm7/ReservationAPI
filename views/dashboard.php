<!DOCTYPE html>
<html lang="pl">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
	<link rel="stylesheet" href="/assets/main.css">
	<title>ReservationAPI - Dashboard</title>
</head>

<body>
	<div class="vh-100 bg-dark text-white d-flex justify-content-center">
		<a href="/logout" class="fs-4 fw-bold btn btn-danger logout-btn m-3 px-4">Logout</a>

		<div class="d-flex flex-column align-items-center my-3 container">
			<div class="mt-5 text-center">
				<h3>Hello, you logged as <?= htmlspecialchars($name); ?> with
					<?php if ($buisness): ?>
						buisness account
					<?php else: ?>
						normal account
					<?php endif ?>
				</h3>
			</div>

			<?php if ($buisness): ?>
				<div class="bg-secondary p-4 rounded-3 my-3">
					<h3 class="fw-bold text-center text-dark">Meeting form creator</h3>
					<form action="/create-meeting" method="post">
						<div class="form-group d-flex flex-column mt-2">
							<label class="ms-2" for="meetingName">Meeting name</label>
							<input class="form-control" type="text" name="meetingName" id="meetingName" placeholder="Enter meeting name">
						</div>
						<div class="form-group d-flex flex-column mt-2">
							<label class="ms-2" for="meetingPlace">Meeting place</label>
							<input class="form-control" type="text" name="meetingPlace" id="meetingPlace" placeholder="Enter meeting place">
						</div>
						<div class="form-group d-flex flex-column mt-2">
							<label class="ms-2" for="meetingDate">Start meeting</label>
							<input class="form-control" value="<?php echo date('Y-m-d\TH:i'); ?>" type="datetime-local" name="meetingDate" id="meetingDate" placeholder="Select date and time">
						</div>
						<button class="btn btn-success fw-bold w-100 mt-3" type="submit">Save meeting</button>
					</form>
				</div>
			<?php endif ?>

			<div class="d-flex align-items-center flex-wrap my-4">
				<?php if ((!empty($meetings)) && empty($meetings['error'])) : ?>
					<?php foreach ($meetings as $meeting): ?>
						<div class="m-auto mb-3">
							<div class="card m-2 <?php if ($buisness) echo 'opacity-50' ?>">
								<div class="card-body" style="cursor: pointer;">
									<h4 class="card-header bg-white text-center"><?php echo ucfirst($meeting['meetingName']) ?></h4>
									<div class="mt-2">Destination: <span class="fw-bold"> <?php echo ucfirst($meeting['meetingPlace']) ?></span></div>
									<div class="mt-2">Start meeting time: <span class="fw-bold"> <?php echo date('Y-m-d H:i', strtotime($meeting['meetingDate'])) ?></span></div>
									<?php if (!$buisness): ?>
										<form action="/confirmmeeting" method="post">
											<input type="hidden" name="meetingId" value="<?= htmlspecialchars($meeting['id']) ?>">
											<?php if (in_array($meeting['id'], $meetingsIds)): ?>
												<button class="w-100 btn btn-primary fw-bold mt-2">Confirmation</button>
											<?php else: ?>
												<button class="w-100 btn btn-success fw-bold mt-2">Confirm meeting</button>
											<?php endif ?>
										</form>
									<?php endif ?>
									<?php if ($meeting['createdBy'] === $_SESSION['userEmail']): ?>
										<a href="/editmeeting?id=<?= $meeting['id'] ?>" class="w-100 btn btn-success fw-bold mt-2">Edit</a>
									<?php endif ?>
								</div>
							</div>
						</div>
					<?php endforeach ?>
				<?php else: ?>
					<h2 class="text-danger">Meetings no exists!</h2>
				<?php endif ?>
			</div>
		</div>
	</div>
</body>

</html>