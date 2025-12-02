<?php

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(\Symfony\Component\HttpFoundation\Response::HTTP_FOUND);
});
