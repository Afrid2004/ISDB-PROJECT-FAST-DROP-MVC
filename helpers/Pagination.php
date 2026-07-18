<?php

class Pagination
{
  private $perPage;
  private $currentPage;
  private $totalRows;
  private $totalPages;

  public function __construct($perPage = 10)
  {
    $this->perPage = $perPage;

    $this->currentPage = isset($_GET['page'])
      ? max(1, (int)$_GET['page'])
      : 1;
  }

  public function paginate($countSql, $dataSql, $types = "", $params = [])
  {
    global $db;

    // Count Total Rows
    $stmt = $db->prepare($countSql);

    if ($types && !empty($params)) {
      $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $this->totalRows = $stmt->get_result()->fetch_assoc()['total'];

    $this->totalPages = ceil($this->totalRows / $this->perPage);

    $offset = ($this->currentPage - 1) * $this->perPage;

    $dataSql .= " LIMIT ?, ?";

    $stmt = $db->prepare($dataSql);

    if ($types) {

      $bindTypes = $types . "ii";

      $params[] = $offset;
      $params[] = $this->perPage;

      $stmt->bind_param($bindTypes, ...$params);
    } else {

      $stmt->bind_param("ii", $offset, $this->perPage);
    }

    $stmt->execute();

    return array_map(
      fn($row) => (object)$row,
      $stmt->get_result()->fetch_all(MYSQLI_ASSOC)
    );
  }

  public function getPerPage()
  {
    return $this->perPage;
  }

  public function getCurrentPage()
  {
    return $this->currentPage;
  }

  public function links()
  {
    if ($this->totalPages <= 1) {
      return "";
    }

    $query = $_GET;
    unset($query['class'], $query['method']);

    $html = '<div class="flex justify-center items-center gap-2 mt-6 flex-wrap">';

    // Previous
    if ($this->currentPage > 1) {

      $query['page'] = $this->currentPage - 1;

      $html .= '<a href="?' . http_build_query($query) . '" 
            class="px-4 py-2 border border-gray-500/30 bg-black/40 rounded hover:bg-black/50 text-white">
            Previous
        </a>';
    }

    $pages = [];

    // Always first page
    $pages[] = 1;

    // Current page -2 to +2
    for ($i = $this->currentPage - 2; $i <= $this->currentPage + 2; $i++) {
      if ($i > 1 && $i < $this->totalPages) {
        $pages[] = $i;
      }
    }

    // Always last page
    if ($this->totalPages > 1) {
      $pages[] = $this->totalPages;
    }

    $pages = array_unique($pages);
    sort($pages);

    $last = 0;

    foreach ($pages as $page) {

      if ($last && $page - $last > 1) {
        $html .= '<span class="px-2 text-white">...</span>';
      }

      $query['page'] = $page;

      $active = $page == $this->currentPage
        ? "bg-primary border-primary text-white"
        : "border border-gray-500/30 bg-black/40 hover:bg-black/50 text-white";

      $html .= '<a href="?' . http_build_query($query) . '"
            class="px-4 py-2 rounded ' . $active . '">
            ' . $page . '
        </a>';

      $last = $page;
    }

    // Next
    if ($this->currentPage < $this->totalPages) {

      $query['page'] = $this->currentPage + 1;

      $html .= '<a href="?' . http_build_query($query) . '" 
            class="px-4 py-2 border border-gray-500/30 bg-black/40 rounded hover:bg-black/50 text-white">
            Next
        </a>';
    }

    $html .= '</div>';

    return $html;
  }
}
